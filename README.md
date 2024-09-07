# Rekogniton Project

## 2. Set Up the Web Server

### Install Apache, PHP, and Composer

1. **Update Packages:**

    ```bash
    sudo yum update -y
    ```

2. **Install Apache:**

    ```bash
    sudo yum install -y httpd
    ```

3. **Start Apache and Enable on Boot:**

    ```bash
    sudo systemctl start httpd
    sudo systemctl enable httpd
    ```

4. **Install PHP:**

    ```bash
    sudo yum install -y php
    ```

5. **Restart Apache to Load PHP:**

    ```bash
    sudo systemctl restart httpd
    ```

6. **Install Composer:**

    ```bash
    curl -sS https://getcomposer.org/installer | php
    sudo mv composer.phar /usr/local/bin/composer
    ```

7. **Verify Composer Installation:**

    ```bash
    composer --version
    ```

### Install PHP AWS SDK

1. **Navigate to Your Web Directory:**

    ```bash
    cd /var/www/html
    ```

2. **Install AWS SDK for PHP:**

    ```bash
    composer require aws/aws-sdk-php
    ```
    **Attach the following policies to the EC2 instance role:**

    - `AmazonS3FullAccess`
    - `AmazonRekognitionFullAccess`
  ### Configure Bucket Policy

1. **Set the following bucket policy for your S3 bucket (`recognitonbucket`):**

    ```json
    {
        "Version": "2012-10-17",
        "Statement": [
            {
                "Effect": "Allow",
                "Principal": "*",
                "Action": [
                    "s3:GetObject",
                    "s3:PutObject"
                ],
                "Resource": "arn:aws:s3:::recognitonbucket/*"
            }
        ]
    }
    ```
### Website Preview

Here is a preview of the website:

![BeFunky-collage](https://github.com/user-attachments/assets/3cf4bff8-f65e-49af-9fd2-3c7271f73f3e)

