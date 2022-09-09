
## About The project

System for upload video files through a high performance scalable system. :video_camera::floppy_disk:

## Getting Started

###Prerequisites

1. PHP8
2. ffmpeg library

### Installation

1. Clone repository

    ```sh
    git clone https://github.com/TheKernelPanic/php8-upload-videos
    ```

2. Install composer dependencies

    ```sh 
   composer install 
   ```
   
3. Create environment file "__.env__" based on "__.env.dist__".
   
### Docker run environment

```bash 
docker-compose -p php8-upload-videos --env-file .env up -d 
```