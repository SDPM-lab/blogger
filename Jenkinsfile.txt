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
					docker version
					docker-compose version
				'''
				}
			}
			
		stage('sonarqube-scanning'){
			steps{
				script{
					withSonarQubeEnv('SDPM_Sonarqube'){
						def scannerHome = tool 'SonarQube_Scanner'
						sh "${scannerHome}/bin/sonar-scanner"
						}
					}
				}
			}
		}
	}