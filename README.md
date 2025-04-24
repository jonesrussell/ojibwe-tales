# Ojibwe Tales - Video Kiosk Platform

A modern kiosk-style application for recording and sharing short videos, inspired by the classic Speakers' Corner concept.

## Project Structure

```
.
├── backend/           # Golang backend services
├── web/              # Laravel + Vue.js web application
└── docs/             # Project documentation
```

## Tech Stack

- **Backend**: Golang
- **Web Application**: Laravel + Vue.js + Inertia.js
- **Database**: PostgreSQL
- **Storage**: AWS S3 (for video storage)
- **Frontend**: Vue.js, TailwindCSS

## Development Setup

### Prerequisites

- Go 1.21+
- PHP 8.2+
- Node.js 18+
- PostgreSQL 15+
- Docker (optional)

### Getting Started

1. Clone the repository
2. Set up the backend services (see backend/README.md)
3. Set up the web application (see web/README.md)
4. Configure environment variables
5. Run the development servers

## Features (MVP)

- Video recording from web interface
- Secure video storage
- Basic user management
- Simple video playback

## Roadmap

- Public website for video sharing
- Mobile applications (Android/iOS)
- Video editing capabilities
- AI-powered features (moderation, transcription)
- Community features

## License

MIT License 