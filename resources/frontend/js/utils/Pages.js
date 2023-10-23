import { Get } from './Fetch'

export const GetPagesByParentId = (pages = [], parentId = -1) => {
    return pages.filter((page) => page.parent_id == parentId);
}

export const GetFullUrl = (page) => {
    return new Promise((resolve, reject) => {
        Get('/api/pages/full-url/' + page.id)
            .then(res => res.json())
            .then(res => {
                if(res.response.status === 200) resolve(res.response.content)
                else reject(res.response.message)
            })
    })
}