pipeline {
    agent {
        docker { 
          image 'webdevops/php-dev:8.1' 
          volumes { hostPath('./app', '/app') // 映射宿主机路径到容器内的WEB_DOCUMENT_ROOT}
        }
    }
    
    stages {
        stage('unit test') {
            steps {
                sh './vendor/bin/phpunit'
            }
        }
        
    }
}
}