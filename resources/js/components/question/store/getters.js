const getQuestion = state => id =>
	state.news.find(question => question.id == id);

const getComments = state => question_id => {
	const question = [...state.list, ...state.news].find(
		question => question.id == question_id
	);

	if (question) return question.comments;
};

export default {
	getQuestion,
	getComments
};
