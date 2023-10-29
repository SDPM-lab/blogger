pipeline {
    agent {
        docker {
            image 'webdevops/php-dev:8.1'
            args '-v $HOME/.app:/app/app'
        }
    }
    
    stages {
        stage('composer install') {
            steps {
                sh 'composer install'
            }
        }
        
        stage('Unit Test') {
            steps {
                sh './vendor/bin/phpunit'
            }
        }
        
    }
}