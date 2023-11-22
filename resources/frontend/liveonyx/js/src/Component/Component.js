import { createComponentTree } from "./Tree"

const safeTimeMeta = document.querySelector(`meta[name="onyx::event-safe-time"]`)

export class Component {
    static COMPONENT_EVENT_LISTENER_PREFIX = '$'
    static EVENT_SAFE_TIME = safeTimeMeta ? safeTimeMeta.getAttribute("content") : 500 // ms

    /**
     * Fake = true is for shadow components
     */
    constructor(rootHandler, fake = false) {
        // Inner Components
        this.components = createComponentTree(rootHandler)

        // Meta
        this.unique = rootHandler.getAttribute("unique")
        this.hash = rootHandler.getAttribute("hash")
        this.rootHandler = document.querySelector(`root[unique="${this.unique}"]`) 

        // Properties and parameters
        this.props = {}
        this.params = {}

        // Event listener timeout
        this.eventListenerTimeout = setTimeout(() => null, 0)

        // Setup component
        if(!fake) this.Setup()
    }

    /**
     * Set root handler
     */
    UpdateRootHandler(rootHandler) {
        this.rootHandler = rootHandler
    }

    /**
     * Setup event listeners
     */
    Setup() {
        const componentJsonDataString = document.querySelector(`script[type="application/json"][id="component-state-${this.unique}"]`)
        const componentJsonData = JSON.parse(componentJsonDataString.innerHTML)

        this.params = componentJsonData.params
        this.props = componentJsonData.props
        this.name = componentJsonData.name

        this.rootHandler.querySelectorAll('*')
            .forEach(element => {
                element.getAttributeNames().forEach(attribute => {
                    if(attribute.startsWith(Component.COMPONENT_EVENT_LISTENER_PREFIX)) {
                        const event = attribute.replace(Component.COMPONENT_EVENT_LISTENER_PREFIX, '')
                        const callbackString = element.getAttribute(attribute)

                        element.addEventListener(event, () => {
                            const callback = eval(callbackString)

                            // Execute callback
                            callback(this)

                            // Refresh
                            clearTimeout(this.eventListenerTimeout)

                            this.eventListenerTimeout = setTimeout(() => {
                                this.UpdateState()
                            }, Component.EVENT_SAFE_TIME)
                        })

                        element.removeAttribute(attribute)
                    }
                })
            })
    }
    

    /**
     * Updates states and re-render via fetch to api
     */
    UpdateState() {
        fetch(`/api/components/render/${this.name}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                "unique": this.unique,
                "state_changes": this.props,
                "parameters": this.params
            })
        })
            .then(res => res.text())
            .then(res => {
                // Creates shadow DOM
                const shadowElement = document.createElement("shadow-div")
                shadowElement.innerHTML = res

                // Get innerHTML of root
                const rootInnerHTML = shadowElement.querySelector('root').innerHTML

                // Re-render
                this.rootHandler.innerHTML = rootInnerHTML
                this.Setup()
            })
    }
}