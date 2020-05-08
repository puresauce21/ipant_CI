<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

// API ERROR MESSAGES Swedish

$lang["already_in"] = "Redan registrerat";
$lang["success"] = "Lyckades";
$lang["record_not_found"] = "Hittades inget";
$lang["saved_card_not_found"] = "Inga sparade kort hittades";
$lang["page_no"] = "sidnummer är obligatoriskt";
$lang["page_no_numeric"] = "Page Number Should Be Numeric";
$lang["lat"]= "Latitude Is Required"; 
$lang["lng"]= "Longitude Is Required";
$lang["is_required"] = "Är obligatoriskt";
$lang["required"] = "Obligatoriska fält är tomma";
$lang["valid_id"] = "skcika giltig ID";
$lang["reset_password"] = "Lösenordet har återställts";
$lang["server_problem"] = "Problem med server. Vänligen försök senare";
$lang["invalid_image"]  = "bilden stöds inte";
$lang["invalid_detail"] = "Ogiltiga detaljer";
$lang["no_user_found"]  = "Inga användare hittades med detta nummer";

// Mobile Number Validation 
$lang["country_code"]   = "Landskod kr?vs";// changes by harish
$lang["mobile_required"]   = "Mobilnummer är obligatoriskt";
$lang["mobile_min_length"] = "Mobilnummer måste vara 9 siffror";
$lang["mobile_max_length"] = "Mobilnummer måste vara 10 siffror";
$lang["mobile_numeric"]    = "Mobile Number Should be Numeric"; 
$lang["mobile_unique"]     = "Mobile Number Should be Unique";

// OTP Validation 
$lang["otp_send"]       = "Engångskoden skickades";
$lang["otp_not_match"]  = "Engångskoden matchar inte";
$lang["otp_max_length"] = "Engångskodens max längd är 6 siffror";
$lang["otp_required"]   = "Engångskod är obligatoriskt";
$lang["otp_numeric"]    = "OTP Should be Numeric"; 
$lang["varify_success"] = "Varifiering lyckades";
$lang["varify_success_signup"] = "Tack ! Vänligen logga in på ditt konto";
//$lang["profile_not_varify"] = "Din profil är inte verifierad än. Vänligen varifiera dig först";
$lang["profile_not_varify"] = "Du är inte registrerad. Vänligen registrera dig först";

// Email Validation
$lang["email_required"] = "E-post adress är obligatoriskt";
$lang["email_valid"]    = "Ogiltig E-post adress"; 
$lang["email_unique"]   = "E-post adressen finns redan registrerad";

// Password Validation
$lang["password_required"]  = "Lösenordet är obligatoriskt";
$lang["password_minlength"] = "Lösenordet måste vara 6-12 tecken";
$lang["password_maxlenght"] = "Lösenordet måste vara 6-12 tecken";

// Signup and Registration 
$lang["country_code_required"] = "landskod är obligatoriskt";
$lang["country_code_length"]   = "maxlängd är 4";

$lang["verification_type_0_1"] = "verifieringstyp mellan 0 till 1";
$lang["verify_id_required"] = "Varifierings ID nummer är obligatoriskt";
$lang["verify_id_unique"] = "Verifierings ID måste vara unikt";
$lang["verify_front"] = "Ansiktsbild är obligatoriskt för varifiering";

$lang["already_register"] = "Redan registrerat. Logga in";
$lang["mobile_not_register"] = "Angivna nummret är inte registrerad";
$lang["thank_msg"] = "Tack! Verifiera ditt nummer för att aktivera ditt konto";



// Registration
$lang["first_name"] = "Namn är obligatorikt";
$lang["last_name"] = "Efternamn är obligatoriskt";
$lang["profile_update"] = "Din profil har uppdaterats";
$lang["profile_notupdate"] = "Din profil uppdaterades inte";
$lang["new_password"] = "Nytt lösenord är obligatoriskt";

// Finger Tip 
$lang["finger_status"] = "Fingeravtryck status ändrades";
$lang["enable_finger"] = "Aktivera fingeravtrycks lås";
$lang["thank_msg1"] = "Tack! Kontrolera din E-post för att aktivera ditt konto";

// Transaction Pin
$lang["old_pin_notmatch"] = "Gammal transaktions PIN matchar inte";
$lang["pin_update"] = "Transaktion PIN uppdaterades";
$lang["pin_require"] = "Transaktion PIN är obligatoriskt";
$lang["pin_length"] = "Transaktion PIN måste vara 4";
$lang["pin_numeric"] = "Transaction Pin Should Be Numeric"; 



$lang["transaction_id"] = "Transaktion ID är obligatoriskt";
$lang["transaction_id_numeric"] = "Transaction ID Should Be Numeric"; 


$lang["transaction_type"] = "Transaktionstyp är obligatoriskt";
$lang["transaction_type_numeric"] = "Transaction Type Should Be Numeric";





// Add Store
/*$lang["store_update"] = "Store uppdaterades";
$lang["store_id"] = "Store är obligatoriskt";
$lang["pharma_name"] = "Apoteksnamn är obligatoriskt";
$lang["pharmacist_name"] = "Apoteksläkarens namn är obligatoriskt";
$lang["category_id"] = "Kategori ID är obligatoriskt";
$lang["category_number"] = "Category Id Should Be Numeric"; 
$lang["contact_number"] = "Contact Number Should Be Numeric"; 
$lang["house_no_required"] = "Lägenhetsnummer är obligatoriskt";
$lang["road_no_required"] = "gatunummer är obligatoriskt";
$lang["division_required"] = "Division Is Required"; 
$lang["country_required"] = "Land är obligatoriskt";*/

// Login
$lang["login_success"] = "Inloggat";
$lang["fingerstatus_required"] = "Fingeravtryck är obligatoriskt";
$lang["fingerstatus_length"] = "Skicka fingeravtrycks status mellan 0 till 1";
$lang["fingercode_required"] = "Fingeravtryk koden är obligatorikt";
//$lang["user_block"] = "Användaren har blockerats ellerr kontot inte är veriferad. Vänligen kontakta iPANT";
$lang["user_block"] = "Använaren har blockerats. Vänligen kontakta iPANT";
$lang["password_notmatch"] = "Lösenordet matchar inte";
$lang["register_first"] = "Denna användare är inte registrerad. Vänligen registrera först";

// Change Password
$lang["password_change_success"] = "Lösenordet har ändrats";
$lang["old_password_not"] = "Gamla lösenordet matchar inte";
$lang["old_password"] = "Gamla lösenordet är obligatoriskt";
$lang["password_not_update"] = "Lösenordet kan inte vara samma";


$lang["logout_success"] = "Utloggad";
$lang["session_expire"] = "Logga in på nytt";
//$lang["header_required"] = "Required Headers Are Empty"; 
//$lang["varify_token_userid"] = "Please Send Valid User Id And Token Number";
$lang["header_required"] = "Obligatoriska rubriker är tomma"; 
$lang["varify_token_userid"] = "inloggning uphörts, logga in på nytt.";

// Help & Support Validation 
$lang["category_required"] = "Category Id Is Required"; 
$lang["category_numeric"] = "Category Id Should be Numeric";

$lang["faq_required"] = "Faq Id Is Required";
$lang["faq_numeric"] = "Faq Id Should be Numeric";

$lang["firstname"]        = "Namn är obligatoriskt";
$lang["lastname"]         = "Efternamn är obligatoriskt";
$lang["subject_required"] = "Rubrik är obligatoriskt";
$lang["msg_required"]     = "Meddelande är obligatoriskt";
$lang["server_error"]     = "Vänligen försök senare";
$lang["feedback_success"] = "Tack för feedback";

//Saved Card Details Validation
$lang["security_code_required"]   = "Säkerhetskod är obligatoriskt";
$lang["security_code_min_length"] = "Säkerhetskoden måste vara 3 siffror";
$lang["security_code_max_length"] = "Säkerhetskoden måste vara 3 siffror";
$lang["security_code_numeric"]    = "Security code should be numeric";

$lang["card_required"]   = "Kort är obligatoriskt";
$lang["card_min_length"] = "Kortnummret måste vara 16 siffror";
$lang["card_max_length"] = "Kortnummret måste vara 16 siffror";
$lang["card_numeric"]    = "Card should be numeric"; 

$lang["expiry_year_required"]   = "Utgångsår måste fyllas";
$lang["expiry_year_min_length"] = "Utgångsår måste vara 4 siffror";
$lang["expiry_year_max_length"] = "Utgångsår måste vara 4 siffror";
$lang["expiry_year_numeric"]    = "Expiry year should be numeric"; 

$lang["expiry_month_required"]           = "Utgångsmånaden måste fyllas i";
$lang["expiry_month_min_length"]         = "Utgångsmånaden måste vara 2 siffror";
$lang["expiry_month_less_than_equal_to"] = "Utgångsmånaden måste vara 1-12";
$lang["expiry_month_greater_than"]       = "Utgångsdatumet måste vara större än 0";
$lang["expiry_month_numeric"]            = "Expiry month should be Numeric"; 

$lang["card_save_success"]         = "Kort informationen sparades";
$lang["card_exist_already"]        = "Kort informationen finns redan";
$lang["card_update_success"]       = "Kort information sparades";
$lang["invalid_expiry_year"]       = "Ogiltig utgångsdatum";
$lang["invalid_expiry_year_month"] = "Ogiltig utgångs år eller månad";
$lang["card_id_required"]          = "Kortnummret åste fyllas i";
$lang["card_id_numeric"]           = "Card id should be numeric";
$lang["card_delete_success"]       = "Kortinformation raderades";

//Saved Bank Details Validation
$lang["bank_name_required"]    = "Bank namn måste fyllas i";
$lang["branch_name_required"]  = "Clearingsnummer måste fyllas I"; 

$lang["acc_number_required"]   = "Kontonummret måste fyllas i"; 
$lang["acc_number_min_length"] = "Kontonummret måste vara 5-14 siffror "; 
$lang["acc_number_max_length"] = "Kontonummret måste vara 5-14 siffror"; 
$lang["acc_number_numeric"]    = "Account number should be numeric";

$lang["bank_save_success"]    = "Bank information sparades"; 
$lang["bank_already_exist"]   = "Bank information finns redan"; 
$lang["bank_update_success"]  = "Bank information uppdaterades"; 
$lang["bank_delete_success"]  = "Bank information raderades"; 

//Send Payment Request Module Validation
$lang["send_request_yourself_error"] = "Du kan inte skicka förfrågan till digsjälv"; 
$lang["mobile_invalid"]              = "mobilnummret är felaktigt"; 
$lang["request_send_success"]        = "betalnings förfråga skickades"; 
$lang["request_send_fail"]           = "Skicka till minst 1 mottagare"; 
$lang["request_required"]            = "Förfråga ID måste fyllas i"; 
$lang["request_numeric"]             = "Request id should be numeric";
$lang["request_decline_success"]     = "Btalningsförfråga accepterades inte"; 
$lang["request_decline_already"]     = "Betalningsförfrågan har redan avböjts"; 
$lang["request_id_invalid"]          = "Ogiltig förfråga ID"; 
$lang["invalid_pin"]                 = "ange giltig ID"; 
$lang["request_accept_success"]      = "Betalningsförfråga accepterades"; 
$lang["insufficient_balance"]        = " Du har inte den summan som krävs för att acceptera förfrågan";
$lang["request_accept_already"]      = "Föfrågan har redan accepterats"; 
$lang["request_cancel_already"]      = "Förfrågan har redan avböjts"; 
$lang["request_cancel_success"]      = "Betalnings föfråga har avböjts"; 

//Withdraw Money Module Validation
$lang["withdraw_success"]      = "Utdrag genomförd"; 
$lang["withdraw_limit_exceed"] = "uttaqgs hösta summa har passerats"; 
$lang["amount_req"]            = "Summan måste anges"; 
$lang["amount_numeric"]        = "Amount should be numeric"; 
$lang["amount_greater_than"]   = "Summan måste vara större än 0"; 

//Send Money Module Validation
$lang["send_money_success"]      = "pengarna har skickats"; 
$lang["send_money_pending"]      = "Överföring bearbets"; 
$lang["send_money_limit_exceed"] = "Anget summa är större än högsta godkända summan";  
$lang["invalid_card_id"]         = "Ogitlig kort information"; 

//Cash Out Module Validation
$lang["cash_out_success"]      = "Hela summan har överförts"; 
$lang["cash_out_limit_exceed"] = "Cashout amount limit exceed."; 

//Share Bill Module validation
$lang["request_share_success"]         = "Share bill request send successfully"; 
$lang["share_request_accept_success"]  = "Share bill request accept successfully";
$lang["share_request_decline_success"] = "Share bill request decline successfully";
$lang["request_share_fail"]            = "Please Send atleast one Receiver details";

$lang["type_no"]                     = "Type number is required";
$lang["type_no_numeric"]             = "Type number should be numeric";
$lang["request_type_required"]       = "Request type is required";
$lang["addmoney_success"]            = "Pengarna har lagts till"; 
$lang["addmoney_pending"]            = "Överforing bearbetas"; 
$lang["payment_success"]             = "Betalningen har genomförts"; 
$lang["send_payment_yourself_error"] = "Du kan inte skicka pengar till dig själv"; 

$lang["id_required"]                 = "ID måste anges"; 
$lang["id_numeric"]                  = "Id should be numeric";
$lang["notification_change_success"] = " Avissering ändringar har sparats";
$lang["not_updated"]                 = "Inte uppdaterad"; 

$lang["is_download_req"]     = "Is download is required";
$lang["is_download_numeric"] = "Is download should be numeric";
$lang['insufficient_wallet_balance'] = 'Du har inte tillräkligt med pengar'; 

//Transaction
$lang["transferred_bank"]  = "Överfört till banken";

$lang["trx_type_withdraw"]  = "Ta ut";
$lang["added_wallet"]  = "Överfört till plånboken";
$lang["trx_type_deposit"]  = "Deposit";
$lang["sent_money"]               = "Skicka pengar till";
$lang["trx_type_sent_money"] = "skickade pengar";
$lang["trx_type_money_received"]  = "mottagna pengar";
$lang["money_received"]  = "pengar tagits emot från";

$lang["trx_type_donate_money"] = "skickade pengar";
$lang["donate_money"]          = "Donera pengar ";
//Rvm machine 
$lang["qrcode_scanned"]= "Din QR kod har skannats";//Rvm machine 
$lang["qrcode_scanned_already"]= "Qr koden har redan skannats";
$lang["qrcode_scanned_by_other"]= "Qr koden har redan använts av en annan användare";
$lang["qrcode_scanned_succ"]= " klart. {amount} kr finns nu i din wallet";

//Donation 
$lang["donation_sucess"]= "Du har framgångsrikt donerat beloppet";





?>