const setList = async ({ commit }, obj) => {
	const list = (await axios.get('/api/questions')).data.questions;

	commit('SET_LIST', { list });
};

const addQuestion = async ({ commit }, obj) => {
	const question = await axios.post('/api/questions', obj);

	commit('ADD_QUESTION', { question });
};

export default {
	setList,
	addQuestion
};
