pipeline {
    agent any

    stages {
        stage('Checkout') {
            steps {
                git branch: 'main', url: 'https://github.com/Castor456/Portfolio-website.git'
            }
        }

        stage('Deploy to Remote Server') {
            steps {
                echo 'Deploying website to remote host...'

		sshagent (credentials: ['cpanelssh']) {
		sh '''
                rsync -avz --delete \
                         --exclude 'README.txt' \
                         --exclude '/.git/' \
                         --exclude '.cpanel.yml' \
                         --exclude '/submissions/' \
                         --exclude 'node_modules/' \
                         --exclude 'Jenkinsfile' \
                         -e "ssh -o StrictHostKeyChecking=no" ./ \
                vmfmzkmy@sh00618.bluehost.com:/home2/vmfmzkmy/repositories/Portfolio-website/
                '''
		}
            }
        }
    }

    post {
        success {
            echo '✅ Deployment complete!'
        }
        failure {
            echo '❌ Deployment failed.'
        }
    }
}
