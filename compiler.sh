echo Building com_gorilla

NOW=$(date +"%Y%m%d%H%M")

cd com_gorilla
zip -r ../com_gorilla.$NOW.zip *
