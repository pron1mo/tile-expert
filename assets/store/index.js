import {reactive, readonly, computed} from 'vue'
import axios from "axios";


// LocalStorage
const Storage = window.localStorage

const updateStorage = () => {
    const data = []
    for (const file of state.files){
        data.push(file.id)
    }
    Storage.setItem('files', JSON.stringify(data))
}
const getFromStorage = () => Storage.getItem('files')

// State
const state = reactive({
    isLoading: true,
    isUploading: false,
    url: '',
    files: [],
    toasts: []
})

// Getters
const getters = {
    getToasts() {
        return state.toasts
    },
}


// Actions
const methods = {
    setUrl(value) {
        state.url = value
    },
    addFile(fileInfo) {
        state.files.push(fileInfo)
    },
    removeFile(fileId) {
        state.files = state.files.filter(file => {
            return file.id !== fileId
        })
    },
    uploadImage() {
        state.isUploading = true;
        if (state.url) {
            axios.post('/upload', {
                url: state.url
            }).then(res => {
                this.addFile({
                    id: res.data.id,
                    src: res.data.src
                })
                this.setUrl('')
                updateStorage()
                state.isUploading = false;
            }).catch(err => {
                this.addToast('danger', err.response.data)
                this.setUrl('')
                state.isUploading = false;
            })
        } else {
            this.addToast('danger', 'Введите Url и повторите попытку!')
            state.isUploading = false;
        }
    },
    deleteImage(fileId) {
        return axios.post('/delete',{
            id: fileId
        })
    },
    addToast(type, message) {
        state.toasts.push({
            type: type,
            message: message
        })
        setTimeout(() => {
            state.toasts = state.toasts.filter(toast => {
                return toast.message !== message
            })
        }, 3000)
    },
    loadFiles() {
        if (JSON.parse(getFromStorage()).length > 0) {
            const ids = JSON.parse(getFromStorage())
            axios.post('/load', {
                ids: ids
            }).then(res => {
                if (res.data){
                    state.files = res.data
                }
                updateStorage()
                state.isLoading = false
            })
        } else {
            state.isLoading = false
        }
    }
}

export default {
    state: readonly(state),
    methods,
    getters
}