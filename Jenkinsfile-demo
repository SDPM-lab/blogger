pipeline {
    agent {
        node {
            label '611177209'
        }
    }
    options {
        skipDefaultCheckout(true)
    }
    stages {
        stage('Clean old DOCs & chekcout SCM') {
            steps {
                echo 'Cleaning old DOCs and checking out SCM...'
                cleanWs()
                checkout scm
            }
        }
        stage('Verify tools') {
            steps {
                echo 'Verifying Docker, Docker Compose, and Composer versions...'
            }
        }
        stage('Start Container') {
            steps {
                echo 'Starting the Docker containers...'
            }
        }
        stage('Dependency installation') {
            steps {
                echo 'Installing dependencies...'
            }
        }
        stage('Environment Setting Up') {
            steps {
                echo 'Setting up the environment...'
            }
        }
        stage('Database migrate') {
            steps {
                echo 'Running database migration...'
            }
        }
        stage('Database seed') {
            steps {
                echo 'Seeding the database...'
            }
        }
        stage('Unit testing') {
            steps {
                echo 'Running unit tests...'
                // junit 'app/build/logs/blogger_unitTest.xml'
            }
        }
    }
    post {
        always {
            echo 'Cleaning up Docker containers...'
        }
    }
}
