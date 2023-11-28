pipeline {
    agent any

    stages {
        stage('front') {
            agent {
                docker {
                    image 'webdevops/php-dev:8.1'
                    args '-v $HOME/app/app:/app' // 確保路徑正確
                }
            }
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
