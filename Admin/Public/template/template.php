<?php 
$config = [
	'platform' => array(
		'shadowpower' => [
			'ios' => [
				'version' => '<{shadowpower+ios}>',
				'server_list' => [
					'1' => [
						'name' => '测试1服',
						'url' => '106.75.20.232',
						'hash' => 'VxwKdlWMYQYJ233',
						'type' => 2
					],
					'2' => [
						'name' => '发行商专区',
						'url' => 'sp.yxlc.shadowpower.cn',
						'hash' => 'VxwKdlWMYQYJlpx',
						'type' => 1
					],
					'3' => [
						'name' => '服务端测试',
						'url' => '192.168.1.188',
						'hash' => 'MISAKA9982',
						'type' => 1
					],
					'4' => [
						'name' => '内部测试',
						'url' => 'sp.yxlc.shadowpower.cn:82',
						'hash' => 'ASDGOJXCVOUJQas',
						'type' => 1
					]			
				]
			],
			'Android' => [
				'version' => '<{shadowpower+Android}>',
				'server_list' => [
					'1' => [
						'name' => '测试1服',
						'url' => '106.75.20.232',
						'hash' => 'VxwKdlWMYQYJ233',
						'type' => 2
					],
					'2' => [
						'name' => '发行商专区',
						'url' => 'sp.yxlc.shadowpower.cn',
						'hash' => 'VxwKdlWMYQYJlpx',
						'type' => 1
					],
					'3' => [
						'name' => '服务端测试',
						'url' => '106.75.20.232',
						'hash' => 'VxasdasMYQYJlpx',
						'type' => 1
					],
					'4' => [
						'name' => '内部测试',
						'url' => 'sp.yxlc.shadowpower.cn:82',
						'hash' => 'ASDGOJXCVOUJQas',
						'type' => 1
					]
				]
			]
		],
		'TapTap' => [
			'ios' => [
				'version' => '<{TapTap+ios}>',
				'server_list' => [
					'1' => [
						'name' => 'taptap专区',
						'url' => 'taptap.yxlc.shadowpower.cn',
						'hash' => 'EmRiAMajiTENShi',
						'type' => 1
					]				
				]
			],
			'Android' => [
				'version' => '<{TapTap+Android}>',
				'server_list' => [
					'1' => [
						'name' => 'taptap专区',
						'url' => 'taptap.yxlc.shadowpower.cn',
						'hash' => 'EmRiAMajiTENShi',
						'type' => 1
					]		
				]
			]
		],
		'Trial' => [
			'ios' => [
				'version' => '<{Trial+ios}>',
				'server_list' => [
					'1' => [
						'name' => '发行专区',
						'url' => '106.75.20.232:86',
						'hash' => 'LoVEliVE9AqOUrS',
						'type' => 1
					]				
				]
			],
			'Android' => [
				'version' => '<{Trial+Android}>',
				'server_list' => [
					'1' => [
						'name' => '发行专区',
						'url' => '106.75.20.232:86',
						'hash' => 'LoVEliVE9AqOUrS',
						'type' => 1
					]		
				]
			]
		],
		'Check' => [
			'ios' => [
				'version' => '<{Check+ios}>',
				'server_list' => [
					'1' => [
						'name' => '游戏一区',
						'url' => '106.75.20.232:88',
						'hash' => 'cIVilizAtIOn',
						'type' => 1
					]				
				]
			],
			'Android' => [
				'version' => '<{Check+Android}>',
				'server_list' => [
					'1' => [
						'name' => '游戏一区',
						'url' => '106.75.20.232:88',
						'hash' => 'cIVilizAtIOn',
						'type' => 1
					]		
				]
			]
		],
	),
	'tablelist' => [
		'yingli' => array(
			'board_information',
			'mail_register',
			'user_account_manager',
			'server_maintenance_manager',
			'user_register_info'
		)
	],
	'database' => [
		'yingli' => array(
			'adapater' => 'Mysql',
			'host' => 'localhost',
			'username' => 'root',
			'password' => 'Misaka!',
			'dbname' => 'identity_manager',
			'charset' => 'utf8',
			'persistent' => true
		)
	],
	'redis' => [
		'master' => array(
            'host' => '127.0.0.1',
            'port' => '6385',
            'password' => 'eMiRiA',
            'persistent' => true,
            'ttl' => 10800,
		)
	],
	'Email' => [
		'yingli' => array(
			'CharSet' => 'UTF-8',
			'Port' => 465,
			'SMTPSecure' => 'ssl',
			'Host' => 'smtp.exmail.qq.com',
			'Username' => 'gm@shadowpower.cn',
			'Password' => 'Gm2016yingli',
			'AddReplyTo' => 'gm@shadowpower.cn',
			'From' => 'gm@shadowpower.cn',
			'FromName' => 'Yingli Co.,Ltd.',
		)
	],
	'validate_mail' => 'http://yxlc.shadowpower.cn::82/original_server/Account/validate',
	'force_update_url' => 'http://yxlc.shadowpower.cn::82/update/'
];

return new \Phalcon\Config($config);