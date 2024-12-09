package my.ipleiria.playxchange;

import android.os.Bundle;
import android.view.Menu;
import android.view.MenuItem;

import androidx.activity.EdgeToEdge;
import androidx.annotation.NonNull;
import androidx.appcompat.app.AppCompatActivity;
import androidx.appcompat.widget.Toolbar;
import androidx.core.graphics.Insets;
import androidx.core.view.ViewCompat;
import androidx.core.view.WindowInsetsCompat;
import androidx.drawerlayout.widget.DrawerLayout;
import androidx.fragment.app.Fragment;
import androidx.fragment.app.FragmentManager;

import com.google.android.material.bottomnavigation.BottomNavigationView;
import com.google.android.material.navigation.NavigationView;

import my.ipleiria.playxchange.fragments.CarrinhoFragment;
import my.ipleiria.playxchange.fragments.HomeFragment;

public class MainActivity extends AppCompatActivity implements NavigationView.OnNavigationItemSelectedListener  {

    private BottomNavigationView navigationView;
    private FragmentManager fragmentManager;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        EdgeToEdge.enable(this);
        setContentView(R.layout.activity_main);
        ViewCompat.setOnApplyWindowInsetsListener(findViewById(R.id.main), (v, insets) -> {
            Insets systemBars = insets.getInsets(WindowInsetsCompat.Type.systemBars());
            v.setPadding(systemBars.left, systemBars.top, systemBars.right, systemBars.bottom);
            return insets;
        });
        navigationView = findViewById(R.id.bottomNavView);
        navigationView.setOnNavigationItemSelectedListener(this::onNavigationItemSelected);
        fragmentManager = getSupportFragmentManager();
        loadStartingFragment();
    }

    private boolean loadStartingFragment()
    {
        Menu menu = navigationView.getMenu();
        MenuItem item = menu.getItem(0);
        item.setChecked(true);
        return onNavigationItemSelected(item);
    }

    @Override
    public boolean onNavigationItemSelected(@NonNull MenuItem item) {
        Fragment fragment = null;

        if (item.getItemId() == R.id.home) {
            setTitle(item.getTitle());
            fragment = new HomeFragment();
        } else if (item.getItemId() == R.id.games) {
            setTitle(item.getTitle());
        } else if (item.getItemId() == R.id.cart) {
            setTitle(item.getTitle());
            fragment = new CarrinhoFragment();
        } else if (item.getItemId() == R.id.orders) {
            setTitle(item.getTitle());
        } else if (item.getItemId() == R.id.user) {
            setTitle(item.getTitle());
        }

        if(fragment!=null){
            fragmentManager.beginTransaction().replace(R.id.contentFragment,fragment).commit();
        }
        return true;
    }
}