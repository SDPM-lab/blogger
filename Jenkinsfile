pipeline {
    agent any

    stages {
        stage('Checkout') {
            steps {
                sh 'ls && cd app/ && ls -al'

            }
        }

        stage('Deploy') {
            steps {
                sh 'docker-compose up -d && docker-compose exec ci4_service composer install && '
            }
        }
    }

    post {
        always {
            // 清理，停止所有服務
            sh 'docker-compose down'
        }
    }
}