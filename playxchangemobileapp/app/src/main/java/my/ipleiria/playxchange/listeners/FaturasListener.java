package my.ipleiria.playxchange.listeners;

import java.util.ArrayList;

import my.ipleiria.playxchange.models.Fatura;

public interface FaturasListener {
    void onRefreshListaFaturas(ArrayList<Fatura> listaFaturas);
    void onRefreshFatura(Fatura fatura);
}
