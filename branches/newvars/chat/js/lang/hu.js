/*
 * @package AJAX_Chat
 * @author Sebastian Tschan
 * @copyright (c) Sebastian Tschan
 * @license GNU Affero General Public License
 * @link https://blueimp.net/ajax/
 */

// Ajax Chat language Object:
var ajaxChatLang = {
	
	login: '%s belépett a chatre.',
	logout: '%s kilépett a chatről.',
	logoutTimeout: '%s kilépett a chatről (Időtúllépés).',
	logoutIP: '%s kilépett a chatről (Hamis IP cím).',
	logoutKicked: '%s ki lett rúgva a chatről.',
	channelEnter: '%s belépett a szobába.',
	channelLeave: '%s kilépett a szobából.',
	privmsg: '(suttog)',
	privmsgto: '(suttog %s felhasználónak)',
	invite: '%s meghívott a következő szobába: %s.',
	inviteto: 'A meghívása %s részére a(z) %s szobába elküldve.',
	uninvite: '%s hívatlan vendégnek tart a(z) %s szobában.',
	uninviteto: 'Hívatlan vendég jelzője %s számára elküldve a(z) %s szobában.',	
	queryOpen: 'Privát szoba megnyitva %s felhasználónak.',
	queryClose: 'Privát szoba bezárva %s felhasználóval.',
	ignoreAdded: '%s hozzáadva a figyelmen kívül hagyottakhoz.',
	ignoreRemoved: '%s eltávolítva a figyelmen kívül hagyottak közül.',
	ignoreList: 'Figyelmen kívül hagyott felhasználók:',
	ignoreListEmpty: 'Nincsenek figyelmen kívül hagyott felhasználók.',
	who: 'Jelenlévők:',
	whoChannel: 'Jelenlévők a(z) %s szobában:',
	whoEmpty: 'Senki nincs a megadott szobában.',
	list: 'Szobák:',
	bans: 'Kitiltott felhasználók:',
	bansEmpty: 'Nincs kitiltott felhasználó.',
	unban: '%s tiltása törölve.',
	whois: '%s IP címe:',
	whereis: '%s a következő szobákban van: %s.',
	roll: '%s rolls %s and gets %s.',
	nick: '%s új nickje %s.',
	toggleUserMenu: '%s - felhasználói menüjének mutatása',
	userMenuLogout: 'Kilépés',
	userMenuWho: 'Jelenlévők listája',
	userMenuList: 'Szobák listája',
	userMenuAction: 'Akció küldése',
	userMenuRoll: 'Dobókocka játék',
	userMenuNick: 'Nick cseréje',
	userMenuEnterPrivateRoom: 'Privát szobába lépés',
	userMenuSendPrivateMessage: 'Privát üzenet küldése',
	userMenuDescribe: 'Privát akció küldése',
	userMenuOpenPrivateChannel: 'Privát szoba nyitása',
	userMenuClosePrivateChannel: 'Privát szoba bezárása',
	userMenuInvite: 'Meghívás',
	userMenuUninvite: 'Hívatlan vendég',
	userMenuIgnore: 'Figyelmen kívül hagy/engedélyez',
	userMenuIgnoreList: 'Figyelmen kívül hagyottak',
	userMenuWhereis: 'Szobák mutatása, ahol jelen van',
	userMenuKick: 'Kirúgás/kitiltás',
	userMenuBans: 'Kitiltottak listája',
	userMenuWhois: 'IP megjelenítése',
	unbanUser: '%s kitiltásának feloldása',
	joinChannel: 'Belépés a szobába %s',
	cite: '%s azt mondja:',
	urlDialog: 'Kérem írja be a honlap URL-jét:',
	deleteMessage: 'Chat üzenet törlése',
	deleteMessageConfirm: 'Valóban törölni akarja az üzenetet?',
	errorCookiesRequired: 'A cookiek engedélyezése szükséges a chat használatához.',
	errorUserNameNotFound: 'Hiba: A %s felhasználó nem található.',
	errorMissingText: 'Hiba: hiányzó üzenet.',
	errorMissingUserName: 'Hiba: hiányzó felhasználónév.',
	errorInvalidUserName: 'Hiba: hamis felhasználónév.',
	errorUserNameInUse: 'Hiba: a név már használatban van.',
	errorMissingChannelName: 'Hiba: hiányzó szoba név.',
	errorInvalidChannelName: 'Hiba: hamis szoba név: %s',
	errorPrivateMessageNotAllowed: 'Hiba: a privát üzenetek nem engedélyezettek.',
	errorInviteNotAllowed: 'Hiba: nem vagy jogosult felhasználókat meghívni a szobába.',
	errorUninviteNotAllowed: 'Hiba: nem vagy jogosult hívatlan vendégnek titulálni bárkit a szobában.',
	errorNoOpenQuery: 'Hiba: nincs jogod szobát nyitni.',
	errorKickNotAllowed: 'Hiba: nincs jogod kirúgni %s-t.',
	errorCommandNotAllowed: 'Hiba: a parancs nem engedélyezett: %s',
	errorUnknownCommand: 'Hiba: ismeretlen parancs: %s',
	errorMaxMessageRate: 'Hiba: elérted a percenként küldhető maximális üzenet számot.',
	errorConnectionTimeout: 'Hiba: időtúllépés! Próbáld újra!.',
	errorConnectionStatus: 'Hiba: a kapcsolat állapota: %s',
	errorSoundIO: 'Hiba: a hangfájl betöltése sikertelen. (I/O)',
	errorSocketIO: 'Hiba: kapcsolódás a socket szerverhez sikertelen. (I/O)',
	errorSocketSecurity: 'Hiba: kapcsolódás a socket szerverhez sikertelen. (Biztonsági hiba!)',
	errorDOMSyntax: 'Hiba: Hibás DOM szintaxis (DOM ID: %s).'
	
}