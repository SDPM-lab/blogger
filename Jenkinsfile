pipeline {
    agent {
        docker { image 'webdevops/php-nginx-dev:8.1' }
    }
    
    stages {
        stage('php version') {
            steps {
                sh 'php --version'
            }
        }
        stage('composer version') {
            steps {
                sh 'composer --version'
            }
        }
        stage('check state') {
            steps {
                sh 'ls -al'
            }
        }
        stage('move') {
            steps {
                sh 'cd app/'
            }
        }
        stage('check state2') {
            steps {
                sh 'ls -al'
            }
        }
        
    }
}