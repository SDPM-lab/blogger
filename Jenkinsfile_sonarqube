pipeline{
  agent{
    node{
      label 'docker'
    }
  }
  stages{
    stage('verify tools'){
     steps{
       sh '''
        docker info
        docker version
        docker-compose version
       '''
     }  
    }
    stage('sq-scanner'){
      steps{
        script{
          withSonarQubeEnv('SDPM_Sonarqube') {
          
            // Execute SonarQube scanner
            def scannerHome = tool 'SonarQube_Scanner'
            sh "${scannerHome}/bin/sonar-scanner"

          }
        }
      }
    }
    stage('Clean all Docker containers'){
      steps{
        sh '''
          docker-compose down -v
          docker system prune -a --volumes -f
        '''
      }
    }
    stage('Start Container'){
      steps{
        sh '''
           docker-compose up -d
        '''
      }
    }
    stage('Dependency installation'){
      steps{
        sh '''
           docker-compose exec -T ci4_service sh -c "ls && composer install"
           docker-compose restart
        '''
      }
    }
    stage('Environment Setting Up'){
      steps{
        script{
          sh '''
            cp app/env app/.env
          '''
        }
      }
    }
    stage('Database migrate'){
      steps{
        sh '''
           docker-compose exec -T ci4_service sh -c "php spark migrate"
        '''
      }
    }
    stage('Database seed'){
      steps{
        sh '''
           sleep 2 
           docker-compose exec -T ci4_service sh -c "php spark migrate"
           docker-compose exec -T ci4_service sh -c "php spark db:seed Members"
           docker-compose exec -T ci4_service sh -c "php spark db:seed TodoLists"
           docker-compose up -d
        '''
      }
    }
    stage('Unit testing'){
      steps{
        sh '''
           docker-compose exec -T ci4_service sh -c "vendor/bin/phpunit"
        '''
      }
    }
   }
}
