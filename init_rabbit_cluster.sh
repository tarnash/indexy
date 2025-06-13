#!/bin/bash

echo "🚀 Joining rabbitmq2 to cluster..."
docker exec indexy-rabbitmq2 rabbitmqctl stop_app
docker exec indexy-rabbitmq2 rabbitmqctl reset
docker exec indexy-rabbitmq2 rabbitmqctl join_cluster rabbit@rabbitmq1
docker exec indexy-rabbitmq2 rabbitmqctl start_app

echo "🚀 Joining rabbitmq3 to cluster..."
docker exec indexy-rabbitmq3 rabbitmqctl stop_app
docker exec indexy-rabbitmq3 rabbitmqctl reset
docker exec indexy-rabbitmq3 rabbitmqctl join_cluster rabbit@rabbitmq1
docker exec indexy-rabbitmq3 rabbitmqctl start_app

echo "✅ Cluster status:"
docker exec indexy-rabbitmq1 rabbitmqctl cluster_status
