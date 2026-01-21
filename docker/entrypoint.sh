#!/bin/sh
set -e

PORT=${PORT:-8080}
export PORT

# Render nginx config with the runtime PORT
if [ -f /etc/nginx/http.d/default.conf.template ]; then
  envsubst '${PORT}' < /etc/nginx/http.d/default.conf.template > /etc/nginx/http.d/default.conf
fi

exec "$@"
