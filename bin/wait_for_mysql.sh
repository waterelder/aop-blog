#!/bin/bash
set -e

host="$1"
shift
cmd="$@"

args=(
	-h $host
	-u "root"
	-D "sys"
	-paopblog
	--silent
)


until select="$(echo 'SELECT 1' | mysql "${args[@]}")" && [ "$select" == '1' ]; do
  >&2 echo "MySQL is unavailable - sleeping"
  sleep 1
done

>&2 echo "MySQL is up - executing command"
eval $cmd