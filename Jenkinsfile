pipeline {
    agent {
        docker { 
          image 'webdevops/php-dev:8.1' 
          volumes { hostPath('./app', '/app') }
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