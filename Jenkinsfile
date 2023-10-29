pipeline {
    
    
    stages {
        stage('front') {
          agent {
              docker {
                image 'webdevops/php-dev:8.1'
                args '-v $HOME/app/app:/app'
              }
          }
          steps {
            step('composer install'){sh 'cd app/ && composer install'}
                
            }
        }
        
      
        
        stage('Unit Test') {
            steps {
                sh 'cd app/ && ./vendor/bin/phpunit'
            }
        }
        
    }
}