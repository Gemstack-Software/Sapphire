import { Component } from "./Component";

export const createComponentFromElement = (element = null) => {
    if(!element) return

    const component = new Component(element)
    return component
}