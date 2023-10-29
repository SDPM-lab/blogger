pipeline {
    agent {
        docker {
            image 'webdevops/php-dev:8.1'
            volumes {
                hostPath('./app', '/app')
            }
        }
    }

    stages {
        stage('Unit Test') {
            steps {
                sh './vendor/bin/phpunit'
            }
        }
    }
}