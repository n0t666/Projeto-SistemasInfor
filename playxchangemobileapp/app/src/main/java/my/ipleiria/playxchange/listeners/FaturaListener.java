package my.ipleiria.playxchange.listeners;

import my.ipleiria.playxchange.models.Fatura;

public interface FaturaListener {
    void onRefreshFatura(Fatura fatura);
    void onCreateFatura(Fatura fatura);
}
