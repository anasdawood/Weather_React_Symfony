import { SIGNED_IN } from '../constants'

export function logUser(userData) {
    const action = {
        type: SIGNED_IN,
        id: userData.id,
        userName: userData.userName,
        userPassword: userData.userPassword
    }
    return action;
}