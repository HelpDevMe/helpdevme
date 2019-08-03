/**
 * Question
 */
const addQuestion = async ({ commit }, obj) => {
	const question = await axios.post('/api/questions', obj);

	commit('ADD_QUESTION', question);
};

const setQuestions = async ({ commit }) => {
	const list = (await axios.get('/api/questions')).data.questions;

	commit('SET_QUESTIONS', list);
};

const setQuestion = async ({ commit }, obj) => {
	commit('SET_QUESTION', obj);
};

/**
 * Comments
 */
const addComment = async ({ commit }, obj) => {
	const comment = await axios.post('/api/comments', obj);

	commit('ADD_COMMENT', comment);
};

const setComment = async ({ commit }, obj) => {
	commit('SET_COMMENT', obj);
};

export default {
	addQuestion,
	setQuestions,
	setQuestion,
	addComment,
	setComment
};
