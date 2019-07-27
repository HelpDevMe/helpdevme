const SET_LIST = (state, obj) => {
	state.list = obj.list;
};

const ADD_QUESTION = (state, obj) => {
	state.news.push(obj);
};

export default {
	SET_LIST,
	ADD_QUESTION
};
