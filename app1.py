# -*- coding: utf-8 -*-
"""ganServer.ipynb

Automatically generated by Colaboratory.

Original file is located at
    https://colab.research.google.com/drive/1g-GYP3bKTk87bw6aoR-Uah5j6WNWcUAQ
"""

import tensorflow as tf
import numpy as np
import os
import cv2
import pandas as pd
from PIL import Image
import neuralgym as ng
from inpaint_model import InpaintCAModel
import io
import json
import requests
import urllib
import uuid
from starlette.requests import Request
from fastapi import FastAPI, File, HTTPException, UploadFile
import uvicorn
from save_image import upload_image_to_s3

app = FastAPI()
model = None
FLAGS = None
sess = None
assign_ops = []

path = 'watermarks/'
output_image_str = 'output_image'
png_format = '.png'
sess_config = tf.ConfigProto()
sess_config.gpu_options.allow_growth = True
checkpoint_dir = 'real_model/'
s3_storage_server = 'https://gan-server.s3.us-east-2.amazonaws.com/'
bucket = 'gan-server'
elastic_ip = 'http://3.20.22.15:8080/'

if not os.path.exists('watermarks'):
  os.mkdir('watermarks')


def init_model():
  global model
  global FLAGS
  FLAGS = ng.Config('inpaint.yml')
  model = InpaintCAModel()

def create_sess():
  global sess
  global assign_ops
  with tf.Session(config=sess_config) as sess:
    vars_list = tf.get_collection(tf.GraphKeys.GLOBAL_VARIABLES)
    for var in vars_list:
      vname = var.name
      from_name = vname
      var_value = tf.contrib.framework.load_variable(checkpoint_dir, from_name)
      assign_ops.append(tf.assign(var, var_value))




def prepare_image(image, mask):
  if image.mode != "RGB" or mask.mode != "RGB":     
    image = image.convert("RGB")
    mask = mask.convert("RGB")
  image = np.array(image)
  mask = np.array(mask)
  assert image.shape == mask.shape
  h, w, _ = image.shape
  grid = 8
  image = image[:h//grid*grid, :w//grid*grid, :]
  mask = mask[:h//grid*grid, :w//grid*grid, :]
  image = np.expand_dims(image, 0)
  mask = np.expand_dims(mask, 0)
  input_image = np.concatenate([image, mask], axis=2)
  return input_image


@app.post("/predict")
def remove_watermark(request_: Request, upload_file: UploadFile=File(...)):
  data = {'success': False}
  if request_.method == "POST":
    json_data = json.load(upload_file.file)
    for i in json_data['watermarks']:
      uid = i['image_id']
      image_url = i['image']
      mask_url = i['mask']
    urllib.request.urlretrieve(image_url, "assets/image_"+uid+".png")
    urllib.request.urlretrieve(mask_url, "assets/mask_"+uid+".png")
    image = Image.open("/assets/image_"+uid+".png")
    mask = Image.open("/assets/mask_"+uid+".png")
    #k = str(uuid.uuid4())
    input_image = prepare_image(image, mask)
    tf.reset_default_graph()

    input_image = tf.constant(input_image, dtype=tf.float32)
    output = model.build_server_graph(FLAGS, input_image)
    output = (output + 1.) * 127.5
    output = tf.reverse(output, [-1])
    output = tf.saturate_cast(output, tf.uint8)
    sess.run(assign_ops)
    result = sess.run(output)
    output_image = result[0][:, :, ::-1]
    data["watermarks"] = []
    output_image_file_path = "{}{}_{}{}".format(path, uid, output_image_str, png_format)
    cv2.imwrite(output_image_file_path, cv2.cvtColor(output_image, cv2.COLOR_BGR2RGB))
    upload_image_to_s3(output_image_file_path, bucket)
    output_image_url = s3_storage_server+output_image_file_path
    r = {'image_id': uid, 'output_image': output_image_url}
    data['watermarks'].append(r)
    data['success'] = True

  return str(data)




if __name__ == "__main__":
  init_model()
  create_sess()
  uvicorn.run(app, host='0.0.0.0', port=8080)