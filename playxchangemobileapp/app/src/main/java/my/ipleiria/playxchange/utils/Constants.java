package my.ipleiria.playxchange.utils;

import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.view.View;

import my.ipleiria.playxchange.ServerActivity;

public class Constants {
    //region - Endpoints
    public static final String LOGIN_ENDPOINT = "users/login";
    //endregion

    //region - User
    public static final String TOKEN = "TOKEN";

    public static final String PROTOCOL = "http://";

    public static String IP_ADDRESS = "IP_ADDRESS";

    public static final String IP_ADRESS_KEY = "IP_ADDRESS";


    public static final String PROJECT = "/Projeto-SistemasInfor/playxchangewebapp/backend/web/api/";

    public static final String DEFAULT_IP =  "http://10.0.2.2" + PROJECT;

    public static final String CURRENT_USER = "CURRENT_USER";
    //endregion

    //region - Validations
    public static final int MIN_USERNAME_LENGTH = 2;
    public static final int MIN_PASSWORD_LENGTH = 8;
    public static final int MAX_BIO_LENGTH = 150;
    public static final int PRIVACY_PUBLIC = 0;
    public static final int PRIVACY_FRIENDS = 1;
    public static final int PRIVACY_PRIVATE = 2;
    public static final int MAX_NAME_LENGTH = 200;
    public static final int NIF_LENGTH = 9;
    public static final int MAX_COMMENT_LENGTH = 2000 ;
    //endregion

    //region - Request Codes
    public static final int REQUEST_CODE_WISHLIST = 1;
    public static final int REQUEST_CODE_PLAYED = 2;
    public static final int REQUEST_CODE_FAVORITES = 3;

    public static final int REQUEST_CODE_ADD_COMMENT = 4;
    public static final int REQUEST_CODE_EDIT_COMMENT = 5;
    //endregion


}
