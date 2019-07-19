import * as mutations from '../../mutation-types';
import * as actions from '../../action-types';

export default {
    [actions.LOGGED_USER](context) {
        return new Promise((resolve, reject) => {
            axios
                .get('/api/user/')
                .then(response => {
                    context.commit(mutations.LOGGED_USER, response.data);
                    resolve(response);
                })
                .catch(error => {
                    reject(error);
                });
        });
    }
};
