import { SIGNED_IN } from '../constants'

let user = {
    id: null,
    userName: null,
    userPassword: null
}

export default (state = user, action) => {
    switch (action.type) {
        case SIGNED_IN:
            const userData = action;
            user = {
                id: userData.id,
                userName: userData.userName,
                userPassword: userData.userPassword
            }
            return user;
        default:
            return state;
    }
}