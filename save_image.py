import boto3
import logging
from botocore.exceptions import ClientError

def upload_image_to_s3(file_name, bucket, object_name=None):
	if object_name is None:
		object_name = file_name

	s3_client = boto3.client('s3')

	try: 
		s3_client.upload_file(file_name, bucket, object_name, ExtraArgs={'ACL': 'public-read'})

	except ClientError as e:
		logging.error(e)
		return False
	return True