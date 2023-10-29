pipeline {
    agent {
        docker { image 'webdevops/php-nginx-dev:8.1' }
    }
    
    stages {
        stage('unit test') {
            steps {
                sh './app/vendor/bin/phpunit'
            }
        }
        
    }
}