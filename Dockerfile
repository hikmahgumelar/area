# build vendor
FROM composer as vendor

## define enviroment variables for datadog-agent
#ENV DD_AGENT_HOST=datadog-agent \
#    DD_TRACE_AGENT_PORT=8126 \
#    DD_TRACE_ANALYTICS_ENABLED=true

WORKDIR /app
COPY composer.json .
COPY database database
COPY app/Helpers app/Helpers
COPY tests tests

RUN composer install \
    --ignore-platform-reqs \
    --no-interaction \
    --no-plugins \
    --no-scripts \
    --prefer-dist

# production stage
FROM hikmahgumelar/iqoswebsrv:latest

COPY --from=vendor --chown=xfs:xfs /app/vendor /app/vendor
COPY --chown=xfs:xfs . .

RUN chmod -R 777 /app/storage
RUN composer dump-autoload
CMD ["/run.sh"]
