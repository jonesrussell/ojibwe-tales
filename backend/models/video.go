package models

import (
	"time"

	"gorm.io/gorm"
)

type Video struct {
	gorm.Model
	Filename    string    `json:"filename"`
	Path        string    `json:"path"`
	Size        int64     `json:"size"`
	Duration    int       `json:"duration"`
	Status      string    `json:"status"` // uploaded, processing, ready
	UploadedAt  time.Time `json:"uploaded_at"`
	ProcessedAt time.Time `json:"processed_at"`
} 