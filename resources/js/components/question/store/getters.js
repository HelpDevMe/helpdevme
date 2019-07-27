const getQuestion = state => id =>
	state.news.find(question => question.id == id);

export default {
	getQuestion
};
