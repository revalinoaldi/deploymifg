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
                        fortify_app_name = 'mifgDokuService'
                        fortify_app_version = '1.0'
                    }
                    steps {
                        withCredentials([string(credentialsId: '14b7283c-954f-49c2-946e-c7d289f3d3e1', variable: 'fortify_token')]) {
                                sh '''
                                 set +x
                                 echo "=================================================="
                                 echo "========--- SAST - Fortify Scan: Start ---========"
                                 echo "=================================================="
                                 scancentral -url https://fortifysast.ifg-life.id:8443/scancentral-ctrl start -bt none \
                                             -python-version 3 -python-requirements requirements.txt \
                                             -upload \
                                             -uptoken $fortify_token \
                                             -version ${fortify_app_version} \
                                             -application ${fortify_app_name}
                                 echo "=================================================="
                                 echo "=========--- SAST - Fortify Scan: End --========="
                                 echo "===TO VIEW THE RESULT VISIT https://fortifyssc.ifg-life.id:8443/ssc==="

                                 echo "=================================================="
                                 echo "========--- OSS - Nexus Scan: Start ---========"
                                 echo "=================================================="
                         '''
                            script {
                                if (env.BRANCH_NAME == 'uat') {
                                    String result = nexusscan("ifgl-doku", "$WORKSPACE/requirements.txt", "stage-release");
                                    echo result;
                                } else if (env.BRANCH_NAME == 'release') {
                                    echo '=================OSS RELEASE, PLEASE ACCESS THE REPORT ON https://oss.ifg-life.id ================='
                                    String result = nexusscan("ifgl-doku", "$WORKSPACE/requirements.txt", "release");
                                    echo result;
                                }
                    }
                }
            }
        }
    }
}
