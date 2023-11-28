pipeline {
    agent {
        docker {
            image 'webdevops/php-dev:8.1'
            args '--entrypoint=\'\' -v $HOME/app/app:/app'
        }
    }

    stages {
        stage('check tool') {
            steps {
                sh 'docker-compose --version'
            }
        }

        stage('Run the project') {
            steps {
                sh 'docker-compose up -d'
            }
        }

        stage('Unit Test') {
            steps {
                sh 'cd app/ && ./vendor/bin/phpunit'
            }
        }
    }
}

