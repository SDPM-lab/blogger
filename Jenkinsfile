pipeline {
    agent {
        docker {
            image 'webdevops/php-dev:8.1'
            args '-v $HOME/app/app:/app'
        }
    }
    
    stages {
        stage('compsoer install') {
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