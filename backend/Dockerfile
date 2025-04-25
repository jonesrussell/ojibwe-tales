# syntax=docker/dockerfile:1

# Build stage
FROM golang:1.24 AS builder

WORKDIR /app

# Copy go mod and sum files
COPY go.mod go.sum ./

# Download all dependencies
RUN go mod download

# Copy the source code and .env file
COPY . .
COPY ../.env .

# Build the application
RUN CGO_ENABLED=0 GOOS=linux go build -o main .

# Final stage
FROM gcr.io/distroless/base-debian11

WORKDIR /

# Copy the binary and .env file from builder
COPY --from=builder /app/main .
COPY --from=builder /app/.env .

# Expose port 8080
EXPOSE 8080

# Use nonroot user
USER nonroot:nonroot

# Command to run the executable
ENTRYPOINT ["/main"] 