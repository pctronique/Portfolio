while read line  
do   
   export $line
done < ${0%/*}/../.env
docker exec -t $NAME_PHP_CONTAINER php /opt/phpDocumentor/vendor/bin/phpdoc "$@"
