#!/bin/bash

GIT_VERSION=$(git rev-parse --abbrev-ref HEAD)

mkdir -p example/generated
mkdir -p clientcompat/generated
go build -ldflags "-w -X main.Version=${GIT_VERSION}" -o build/protoc-gen-twirp_php ./protoc-gen-twirp_php
protoc -I ./example/ --plugin=protoc-gen-twirp_php=build/protoc-gen-twirp_php --twirp_php_out=example/generated/ --php_out=example/generated/ service.proto
protoc -I ./clientcompat/ --plugin=protoc-gen-twirp_php=build/protoc-gen-twirp_php --twirp_php_out=clientcompat/generated/ --php_out=clientcompat/generated/ clientcompat.proto
