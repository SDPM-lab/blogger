pipeline {
    agent {
        docker {
            image 'webdevops/php-dev:8.1'
            args '--entrypoint=\'\' -v $HOME/app/app:/app'
        }
    }

    stages {
        stage('front') {
            steps {
                sh 'cd app/ && composer install'
            }
        }
        
        stage('Unit Test') {
            steps {
                sh 'cd app/ && ./vendor/bin/phpunit'
            }
        }
    }
}

