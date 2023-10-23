<script setup>
    import { onMounted } from "vue"
    import { Post } from "../../utils/Fetch"
    import VSDark from '../../themes/vs-dark'
    import { Notify, NotifyRed } from "../../utils/Notifications"

    const { file, folder, type } = defineProps({
        file: String,
        folder: String,
        type: String
    }) 

    ///////////////////////////////////////////
    // Get language
    ///////////////////////////////////////////
    const GetLanguage = () => null

    ///////////////////////////////////////////
    // Make the editor
    ///////////////////////////////////////////
    window.provideMonacoEditor().editor.defineTheme('vs-dark', VSDark)
    
    let editor;

    onMounted(() => {
        setTimeout(() => {
            editor = window.provideMonacoEditor().editor.create(document.querySelector('#monaco-container'), {
                language: "php",
                theme: "vs-dark",
                baseUrl: "/assets",
                tabSize: 4
            })

            GetEditorContent(file, folder, type)
        }, 10)
    })

    ////////////////////////////////////////////////
    // Get it's content
    ////////////////////////////////////////////////
    const GetEditorContent = (_file, _folder, _type) => {
        Post('/api/app-files/file', {
                filename: _file,
                inner_folder: _folder,
                outer_folder: _type + 's'
            })
                .then(res => res.json())
                .then(res => {
                    if(res.response.status === 200) {
                        editor.setValue(res.response.content)
                        SaveListen()
                    }
                })

        return ""
    }

    //////////////////////////////////////////////////////
    // Events emitter
    //////////////////////////////////////////////////////
    const $emit = defineEmits([
        "SaveStart",
        "SaveEnd"
    ])

    //////////////////////////////////////////////////////
    // Saving and Autosaving
    //////////////////////////////////////////////////////
    const Save = () => new Promise((resolve, reject) => {
        Post('/api/app-files/save', {
            file: window.currentFile,
            inner_folder: window.currentFolder,
            outer_folder: window.currentType + 's',
            content: editor.getValue()
        })
            .then(res => res.json())
            .then(res => {
                if(res.response.status === 200) resolve()
                else reject(res.response.message)
            })
    })

    const SaveStart = () => $emit("SaveStart", null)
    const SaveEnd = () => $emit("SaveEnd", null)

    function SaveListen() {
        let timeout;

        editor.onDidChangeModelContent(() => {
            if(timeout) clearTimeout(timeout)

            timeout = setTimeout(() => {
                SaveStart()

                Save().then(() => SaveEnd()).catch(err => {
                    Notify(err, NotifyRed, "fas fa-exclamation-triangle")
                })
            }, 250)
        })
    }

    // const StartAutosaver = () => {
    //     setInterval(() => {
    //         //SaveStart()
    // 
    //         Save().then(() => {
    //             // setTimeout(() => SaveEnd(), 0)
    //         }).catch(err => {
    //             Notify(err, NotifyRed, "fas fa-exclamation-triangle")
    //         })
    //     }, 500)
    // 
    //     return ""
    // }
    //
    // StartAutosaver()
</script>

<template>
    <div class="monaco-container__outer">
        {{ GetEditorContent(file, folder, type) }}

        <div id="monaco-container"></div>      
    </div>
</template>

<style lang="scss" scoped>
    .monaco-container__outer, #monaco-container {
        height: calc(100vh - 86px);
        position: relative;
    }

    .monaco-container__outer {
        #monaco-container {
            height: calc(100% - 0px);
        }
    }
</style>