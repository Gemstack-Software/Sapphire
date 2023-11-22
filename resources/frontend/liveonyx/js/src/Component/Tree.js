import { createComponentFromElement } from "./Creates"

/**
 * Creates tree of components
 */

export const createComponentTree = (root = document.documentElement) => {
    const treeBaseArray = []
    const rootClone = root.cloneNode(true)

    while(rootClone.querySelector('root')) {
        const real = rootClone.querySelector('root')
        const clone = real.cloneNode(true)

        const instance = createComponentFromElement(clone)
        treeBaseArray.push(instance)

        real.remove()
    }

    /**
     * Returns components
     */
    return treeBaseArray
}