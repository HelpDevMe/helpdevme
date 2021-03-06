/**
 * PRIVATE
 */
const question = ({ list, news }, question_id) =>
	[...list, ...news].find(question => question.id == question_id);

/**
 * Questions
 */
const ADD_QUESTION = ({ news }, response) =>
	news.unshift(response.data.question);

const SET_QUESTIONS = (state, questions) => (state.list = questions);

const SET_QUESTION = ({ news }, question) => news.unshift(question);

/**
 * Comments
 */
const ADD_COMMENT = (state, { data }) =>
	question(state, data.post.talk.question_id).comments.push(data.post);

const SET_COMMENT = (state, comment) =>
	question(state, comment.talk.question_id).comments.push(comment);

export default {
	ADD_QUESTION,
	SET_QUESTIONS,
	SET_QUESTION,
	ADD_COMMENT,
	SET_COMMENT
};
