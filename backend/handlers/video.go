package handlers

import (
	"log"
	"net/http"
	"time"

	"github.com/gin-gonic/gin"
	"github.com/minio/minio-go/v7"
	"github.com/ojibwe-tales/backend/models"
	"gorm.io/gorm"
)

type VideoHandler struct {
	db     *gorm.DB
	minio  *minio.Client
	bucket string
}

func NewVideoHandler(db *gorm.DB, minio *minio.Client, bucket string) *VideoHandler {
	return &VideoHandler{
		db:     db,
		minio:  minio,
		bucket: bucket,
	}
}

func (h *VideoHandler) ProcessVideo(c *gin.Context) {
	// Get video file from request
	file, err := c.FormFile("video")
	if err != nil {
		c.JSON(http.StatusBadRequest, gin.H{"error": err.Error()})
		return
	}

	// Open the file
	src, err := file.Open()
	if err != nil {
		c.JSON(http.StatusInternalServerError, gin.H{"error": err.Error()})
		return
	}
	defer src.Close()

	// Upload to MinIO
	objectName := time.Now().Format("2006-01-02") + "/" + file.Filename
	_, err = h.minio.PutObject(c, h.bucket, objectName, src, file.Size, minio.PutObjectOptions{
		ContentType: "video/webm",
	})
	if err != nil {
		c.JSON(http.StatusInternalServerError, gin.H{"error": err.Error()})
		return
	}

	// Create video record in database
	video := models.Video{
		Filename:   file.Filename,
		Path:       objectName,
		Size:       file.Size,
		Status:     "uploaded",
		UploadedAt: time.Now(),
	}

	if err := h.db.Create(&video).Error; err != nil {
		log.Printf("Error creating video record: %v", err)
		c.JSON(http.StatusInternalServerError, gin.H{"error": "Failed to save video metadata"})
		return
	}

	c.JSON(http.StatusOK, gin.H{
		"message": "Video uploaded successfully",
		"video":   video,
	})
} 