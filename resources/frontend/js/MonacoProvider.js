import * as Editor from 'monaco-editor'
import 'monaco-editor/min/vs/editor/editor.main.css'

/**
 * Provides Monaco Editor class (via window object to not enlarge size of app.js)
 */
if(window) window.provideMonacoEditor = () => Editor;