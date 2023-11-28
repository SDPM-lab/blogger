pipeline {
    agent any

    stages {
        stage('Checkout') {
            steps {
                sh 'cd app/ && cp env .env'

            }
        }

        stage('Deploy') {
            steps {
                sh 'docker-compose up -d && docker-compose exec ci4_service composer install && docker-compose exec ci4_service php spark migrate && docker-compose exec ci4_service php spark db:seed Members && docker-compose exec ci4_service php spark db:seed TodoLists'
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