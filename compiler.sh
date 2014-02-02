echo Building com_gorilla

NOW=$(date +"%Y%m%d%H%M")

cd /home/rodrigo/git/Gorilla
rm com_gorilla*.zip
cd com_gorilla
zip -r ../com_gorilla.$NOW.zip *
