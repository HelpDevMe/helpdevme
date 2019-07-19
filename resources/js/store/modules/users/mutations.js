import * as types from '../../mutation-types';

export default {
    [types.LOGGED_USER](state, user) {
        state.logged_user = user;
    }
};
