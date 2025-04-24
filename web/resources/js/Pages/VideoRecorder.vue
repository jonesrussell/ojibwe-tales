<template>
  <div class="min-h-screen bg-gray-100">
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
      <div class="px-4 py-6 sm:px-0">
        <div class="bg-white rounded-lg shadow-lg p-6">
          <h2 class="text-2xl font-bold mb-4">Record Your Story</h2>
          
          <div class="mb-4">
            <video
              ref="videoElement"
              class="w-full rounded-lg"
              autoplay
              muted
            ></video>
          </div>

          <div class="flex justify-center space-x-4">
            <button
              v-if="!isRecording"
              @click="startRecording"
              class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
            >
              Start Recording
            </button>
            <button
              v-else
              @click="stopRecording"
              class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded"
            >
              Stop Recording
            </button>
          </div>

          <div v-if="recordedVideo" class="mt-4">
            <h3 class="text-xl font-semibold mb-2">Preview</h3>
            <video
              :src="recordedVideo"
              controls
              class="w-full rounded-lg"
            ></video>
            <button
              @click="uploadVideo"
              class="mt-4 bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded"
            >
              Upload Video
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'

const videoElement = ref(null)
const mediaRecorder = ref(null)
const recordedChunks = ref([])
const recordedVideo = ref(null)
const isRecording = ref(false)

onMounted(async () => {
  try {
    const stream = await navigator.mediaDevices.getUserMedia({ video: true, audio: true })
    videoElement.value.srcObject = stream
  } catch (err) {
    console.error('Error accessing media devices:', err)
  }
})

const startRecording = () => {
  recordedChunks.value = []
  const stream = videoElement.value.srcObject
  mediaRecorder.value = new MediaRecorder(stream)

  mediaRecorder.value.ondataavailable = (event) => {
    if (event.data.size > 0) {
      recordedChunks.value.push(event.data)
    }
  }

  mediaRecorder.value.onstop = () => {
    const blob = new Blob(recordedChunks.value, { type: 'video/webm' })
    recordedVideo.value = URL.createObjectURL(blob)
  }

  mediaRecorder.value.start()
  isRecording.value = true
}

const stopRecording = () => {
  mediaRecorder.value.stop()
  isRecording.value = false
}

const uploadVideo = async () => {
  const blob = new Blob(recordedChunks.value, { type: 'video/webm' })
  const formData = new FormData()
  formData.append('video', blob, 'recording.webm')

  try {
    const response = await fetch('/api/videos', {
      method: 'POST',
      body: formData,
    })

    if (response.ok) {
      alert('Video uploaded successfully!')
    } else {
      throw new Error('Upload failed')
    }
  } catch (error) {
    console.error('Error uploading video:', error)
    alert('Failed to upload video. Please try again.')
  }
}
</script> 