pipeline {
    agent nigger2

    stages {
        stage('Checkout') {
            steps {
                sh 'ls'
            }
        }

        stage('Deploy') {
            steps {
                sh 'docker-compose up -d && docker-compose exec ci4_service composer install'
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