library('jenkins-shared-library') _
pipeline {
    agent none
    stages {
                stage("security-fortify-scan") {
                    when {
                        beforeAgent true
                        not {
                            branch 'development'
                        }
                    }
                    agent {
                        node {
                            label 'sast'
                        }
                    }
                    environment {
                        fortify_app_name = 'mifgFrontendService'
                        fortify_app_version = '1.0'
                    }
                    steps {
                        withCredentials([string(credentialsId: '14b7283c-954f-49c2-946e-c7d289f3d3e1', variable: 'fortify_token')]) {
                                sh '''
                                 set +x

                                 echo "=================================================="
                                 echo "========--- OSS - Nexus Scan: Start ---========"
                                 echo "=================================================="
                         '''
                            script {
                                if (env.BRANCH_NAME == 'uat') {
                                    String result = nexusscan("ifgl-frontend", "$WORKSPACE", "stage-release");
                                    echo result;
                                } else if (env.BRANCH_NAME == 'release') {
                                    echo '=================OSS RELEASE, PLEASE ACCESS THE REPORT ON https://oss.ifg-life.id ================='
                                    String result = nexusscan("ifgl-frontend", "$WORKSPACE", "release");
                                    echo result;
                                }
                    }
                }
            }
        }
    }
}

