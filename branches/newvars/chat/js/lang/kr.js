﻿/*
 * @package AJAX_Chat
 * @author Sebastian Tschan
 * @copyright (c) Sebastian Tschan
 * @license GNU Affero General Public License
 * @link https://blueimp.net/ajax/
 */

// Ajax Chat language Object:
var ajaxChatLang = {
	
	login: '%s께서 접속하였습니다.',
	logout: '%s님께서 접속을 종료하였습니다.',
	logoutTimeout: '%s님께서 시간초과로 나가셨습니다.',
	logoutIP: '%s님께서 IP주소문제로 나가셨습니다.',
	logoutKicked: '%s님께서 추방되었습니다.',
	channelEnter: '%s님께서 들어오셨습니다.',
	channelLeave: '%s님께서 나가셨습니다.',
	privmsg: '(귓속말)',
	privmsgto: '(%s에게 귓속말)',
	invite: '%s님께서 %s채널에서 초대하셨습니다.',
	inviteto: '%s을 %s채널로 초대하는 메시지를 보냈습니다..',
	uninvite: '%s님께서 %s채널로의 초대를 취소하였습니다.',
	uninviteto: '%s님께 %s채널로의 초대를 취소하는 메시지를 보냈습니다',	
	queryOpen: '%s님의 개인채널이 열렸습니다.',
	queryClose: '%s님의 개인채널이 닫혔습니다.',
	ignoreAdded: '%s님을 대화차단 목록에 추가하였습니다.',
	ignoreRemoved: '%s님을 대화차단 목록에서 삭제하였습니다.',
	ignoreList: '차단된 사용자:',
	ignoreListEmpty: '차단된 사용자가 없습니다.',
	who: '접속중인 사용자:',
	whoChannel: '%s채널에 접속중인 사용자:',
	whoEmpty: '해당 채널에 접속중인 사용자가 없습니다.',
	list: '사용가능한 채널:',
	bans: '추방된 사용자:',
	bansEmpty: '추방된 사용자가 없습니다.',
	unban: '%s을 다시 복구하였습니다.',
	whois: '%s - IP주소:',
	whereis: '%s님은 %s 채널에 계십니다.',
	roll: '%s rolls %s and gets %s.',
	nick: '%s님의 닉네임은 %s입니다.',
	toggleUserMenu: 'Toggle user menu for %s',
	userMenuLogout: '로그아웃',
	userMenuWho: '접속중인 사용자',
	userMenuList: '채널목록',
	userMenuAction: 'Describe action',
	userMenuRoll: '주사위',
	userMenuNick: '대화명 변경',
	userMenuEnterPrivateRoom: '개인 대화방 입장',
	userMenuSendPrivateMessage: '귓속말 전송',
	userMenuDescribe: 'Send private action',
	userMenuOpenPrivateChannel: '개인 채널 개설',
	userMenuClosePrivateChannel: '개인 채널 닫기',
	userMenuInvite: '초대',
	userMenuUninvite: '초대 취소',
	userMenuIgnore: '차단/수락',
	userMenuIgnoreList: '대화차단 목록',
	userMenuWhereis: '채널확인',
	userMenuKick: '추방',
	userMenuBans: '추방된 사용자 목록',
	userMenuWhois: '접속주소 확인',
	unbanUser: '%s 사용자를 추방취소',
	joinChannel: '%s 채널에 접속',
	cite: '%s님의 말:',
	urlDialog: '웹페이지의 주소를 입력하세요:',
	deleteMessage: '이 메시지 삭제',
	deleteMessageConfirm: '선택한 메시지를 삭제하시겠습니까?',
	errorCookiesRequired: '쿠키 사용으로 설정하세요.',
	errorUserNameNotFound: 'Error: %s님을 찾을 수 없습니다.',
	errorMissingText: 'Error: 메시지를 찾을 수 없습니다.',
	errorMissingUserName: 'Error: 대화명을 찾을 수 없습니다.',
	errorInvalidUserName: 'Error: 잘못된 대화명입니다.',
	errorUserNameInUse: 'Error: 이미 사용중인 대화명입니다.',
	errorMissingChannelName: 'Error: 채널명을 찾을 수 없습니다.',
	errorInvalidChannelName: 'Error: %s 채널이 없습니다.',
	errorPrivateMessageNotAllowed: 'Error: 귓속말을 사용할 수 없습니다.',
	errorInviteNotAllowed: 'Error: 이 채널로 다른 사용자를 초대하는 권한이 없습니다.',
	errorUninviteNotAllowed: 'Error: 다른 사용자의 초대를 취소할 권한이 없습니다.',
	errorNoOpenQuery: 'Error: 열려있는 개인 채널이 없습니다..',
	errorKickNotAllowed: 'Error: %s를 추방할 수 있는 권한이 없습니다.',
	errorCommandNotAllowed: 'Error: %s 명령을 사용할 수 없습니다.',
	errorUnknownCommand: 'Error: %s은 없는 명령어입니다.',
	errorMaxMessageRate: 'Error: 1분동안 연속해서 입력할 수 있는 메시지 수를 초과하였습니다.',
	errorConnectionTimeout: 'Error: 접속시간을 초과하였습니다.',
	errorConnectionStatus: 'Error: 접속 상태: %s',
	errorSoundIO: 'Error: 입출력 실패로 소리파일을 불러오는데 실패하였습니다.',
	errorSocketIO: 'Error: 입출력 실패로 서버에 접속하는데 실패하였습니다.',
	errorSocketSecurity: 'Error: 보안문제로 서버에 접속하는데 실패하였습니다.',
	errorDOMSyntax: 'Error: DOM 문법이 잘못되었습니다. (DOM ID: %s).'
	
}