<?php

return [
	'create' => '创建',
	'save' => '保存',
	'edit' => '编辑',
	'view' => '查看',
	'update' => '更新',
	'list' => 'List',
	'no_entries_in_table' => '没有任何条目在当前列表中',
	'custom_controller_index' => 'Custom controller index.',
	'logout' => '退出',
	'add_new' => '新增',
	'are_you_sure' => 'Are you sure?',
	'back_to_list' => '返回列表',
	'dashboard' => '主页',
	'delete' => '删除',
	'quickadmin_title' => '在线考试系统',

	'user-management' => [
		'title' => '用户管理',
		'fields' => [
		],
	],

    'test' => [
        'new' => '新测试',
    ],

	'roles' => [
		'title' => '角色',
		'fields' => [
			'title' => '角色',
		],
	],

	'users' => [
		'title' => '用户',
		'fields' => [
			'name' => '姓名',
			'email' => '邮箱',
			'password' => '密码',
			'role' => '角色',
			'remember-token' => 'Remember token',
		],
	],

	'user-actions' => [
		'title' => '用户行为记录',
		'fields' => [
			'user' => '用户',
			'action' => '行为',
			'action-model' => 'Action model',
			'action-id' => 'Action id',
		],
	],

	'topics' => [
		'title' => '测试库',
		'fields' => [
			'title' => 'Title',
		],
	],

	'questions' => [
		'title' => '试题题目',
		'fields' => [
			'topic' => '测试库',
			'question-text' => '题目描述',
			'code-snippet' => 'Code snippet',
			'answer-explanation' => '答案解析',
			'more-info-link' => '关于更多',
		],
	],

	'questions-options' => [
		'title' => '试题选项',
		'fields' => [
			'question' => '试题题目',
			'option' => '试题选项',
			'correct' => 'Correct',
		],
	],

	'results' => [
		'title' => '我的考试结果',
		'fields' => [
			'user' => '用户',
			'question' => '问题',
			'correct' => 'Correct',
			'date' => '日期',
			'result' => '得分',
		],
	],

	'laravel-quiz' => '新的考试测试',
	'quiz' => '回答下面十道题, 没有时间限制',
	'submit_quiz' => '提交答案',
	'view-result' => '显示结果',

];
